<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\MediaQueueException;
use App\Models\Media;
use App\Models\Request;
use App\Models\User;
use DanielDeWit\LighthouseSanctum\Traits\HasAuthenticatedUser;
use DanielDeWit\LighthouseSanctum\Traits\HasUserModel;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;
use Nuwave\Lighthouse\Execution\Utils\Subscription;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Illuminate\Database\Eloquent\Model;

/**
 * Override the original class because that always expects an email & password combination
 * Shoutz0r however uses a username & password combination
 */
class AddRequest
{
    use HasAuthenticatedUser;
    use HasUserModel;

    protected AuthFactory $authFactory;

    public function __construct(AuthFactory $authFactory)
    {
        $this->authFactory = $authFactory;
    }

    /**
     * @param ResolveInfo $resolveInfo
     * @return string[]
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])] public function __invoke($_, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): array
    {
        $this->resolveInfo = $resolveInfo;

        $user = $this->getAuthenticatedUser();
        $user = $this->getModelFromUser($user);
        $media = Media::find($args['id']);

        // Default feedback
        $success = false;

        try {
            $this->userCanRequest($user);
            $this->isMediaRequestable($media);
            $this->isArtistRequestable($media);

            $request = Request::create([
                'media_id' => $media->id,
                'requested_by' => $user->id,
                'played_at' => null
            ]);

            Subscription::broadcast('requestAdded', $request);

            $success = true;
            $message = 'The request has been added to the queue';
        }
        catch (MediaQueueException $e) {
            $message = $e->getMessage();
        }
        catch (QueryException $e) {
            $message = "Something went wrong while adding the request";
            Log::error("Failed to add user request to the database, error: {$e->getMessage()}");
        }

        return [
            'success' => $success,
            'message' => $message
        ];
    }

    protected function getAuthFactory(): AuthFactory
    {
        return $this->authFactory;
    }

    /**
     * Determines if the user is able to make a request at this moment
     * ie: requested something too recently
     * @param User $user
     * @return void
     * @throws MediaQueueException
     */
    private function userCanRequest(Model $user): void
    {
        $recent = Request::query()
            ->whereRaw('
                requested_by = ? AND
                requested_at > ?
            ', [
                $user->id,
                Carbon::now()->subSeconds(config('shoutzor.userRequestDelay'))
            ])
            ->orderBy('requested_at', 'DESC')
            ->limit(1)
            ->first();

        if($recent) {
            throw new MediaQueueException("You have requested media too recently, please try again later.");
        }
    }

    /**
     * Determines if the provided media object is requestable
     * ie: not requested too recently
     * @param Media $media
     * @return void
     * @throws MediaQueueException
     */
    private function isMediaRequestable(Media $media): void
    {
        $recent = Request::query()
            ->whereRaw('
                (
                    requests.media_id = ? AND
                    played_at > ?
                ) OR
                (
                    requests.media_id = ? AND
                    played_at IS NULL
                )
            ', [
                $media->id,
                Carbon::now()->subSeconds(config('shoutzor.mediaRequestDelay')),
                $media->id
            ])
            ->orderBy('requested_at', 'DESC')
            ->limit(1)
            ->first();

        if($recent) {
            // If played_at is null it means this file is already in the queue
            // Otherwise, it has been played too recently
            throw new MediaQueueException(
                $recent->played_at === null ?
                    "This media is already in the queue" :
                    "This media has been played too recently, please try again later.");
        }
    }

    /**
     * Determines if the artist of the provided media object is requestable
     * ie: no tracks of the artist have been played too recently
     * @param Media $media
     * @return void
     * @throws MediaQueueException
     */
    private function isArtistRequestable(Media $media): void
    {
        $artists = $media->artists()->pluck('id')->toArray();

        // If the media has no (known) artist, then it can be requested regardless
        if(!$artists) {
            return;
        }

        $recent = Request::query()
            ->leftJoin('artist_media', 'artist_media.media_id', '=', 'requests.media_id')
            ->whereRaw('
                (
                    artist_media.artist_id IN (' . str_repeat('?,', count($artists) - 1) . '?) AND
                    played_at > ?
                ) OR
                (
                    artist_media.artist_id IN (' . str_repeat('?,', count($artists) - 1) . '?) AND
                    played_at IS NULL
                )
            ', array_merge(
                $artists,
                [Carbon::now()->subSeconds(config('shoutzor.artistRequestDelay'))],
                $artists
            ))
            ->orderBy('requested_at', 'DESC')
            ->limit(1)
            ->first();

        if($recent) {
            throw new MediaQueueException(
                $recent->played_at === null ?
                    "This artist is already in the queue" :
                    "This artist has been played too recently, please try again later.");
        }
    }
}
