<?php

namespace App\GraphQL\Mutations;

use App\Models\Media;
use App\Models\Request;
use App\Models\User;
use DanielDeWit\LighthouseSanctum\Traits\HasAuthenticatedUser;
use DanielDeWit\LighthouseSanctum\Traits\HasUserModel;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;
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
        $success = true;
        $message = 'The request has been added to the queue';

        if(!$media) {
            $success = false;
            $message = 'The requested media does not exist';
        }
        // Check if the user can perform a request
        elseif(!$this->userCanRequest($user)) {
            $success = false;
            $message = 'You have requested media too recently, please try again later.';
        }
        // Check if the media file has not been played too recently
        elseif(!$this->isMediaRequestable($media)) {
            $success = false;
            $message = 'This media has been played too recently, please try again later.';
        }
        // Check if the artist has not been played too recently
        elseif(!$this->isArtistRequestable($media)) {
            $success = false;
            $message = 'The artist has been played too recently, please try again later.';
        }
        // All validation checks have passed, add the request to the database
        else {
            try {
                Request::create([
                    'media_id' => $media->id,
                    'requested_by' => $user->id,
                    'played_at' => null
                ]);
            } catch (QueryException $e) {
                $success = false;
                $message = "Something went wrong while adding the request";
                Log::error("Failed to add user request to the database, error: {$e->getMessage()}");
            }
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
     * @return bool
     */
    private function userCanRequest(Model $user): bool
    {
        $recent = Request::query()
            ->whereRaw('
                requested_by = ? AND
                requested_at >= (CURRENT_TIMESTAMP() - ?)
            ', [
                $user->id,
                config('shoutzor.userRequestDelay')
            ])
            ->orderBy('requested_at', 'DESC')
            ->limit(1)
            ->first();

        // Check if a result has been found, if not, the user can request the track
        return !$recent;
    }

    /**
     * Determines if the provided media object is requestable
     * ie: not requested too recently
     * @param Media $media
     * @return false
     */
    private function isMediaRequestable(Media $media): bool
    {
        $recent = Request::query()
            ->whereRaw('
                requests.media_id = ? AND
                requested_at > (CURRENT_TIMESTAMP() - ?)
            ', [
                $media->id,
                config('shoutzor.mediaRequestDelay')
            ])
            ->orderBy('requested_at', 'DESC')
            ->limit(1)
            ->first();

        // If no results are found, the media file is requestable
        return !$recent;
    }

    /**
     * Determines if the artist of the provided media object is requestable
     * ie: no tracks of the artist have been played too recently
     * @param Media $media
     * @return false
     */
    private function isArtistRequestable(Media $media): bool
    {
        $artists = $media->artists()->pluck('id')->toArray();

        // If the media has no (known) artist, then it can be requested regardless
        if(!$artists) {
            return true;
        }

        $recent = Request::query()
            ->whereRaw('
                requests.media_id IN (
                    SELECT media_id
                    FROM `artist_media`
                    WHERE artist_id IN (' . str_repeat('?,', count($artists) - 1) . '?)
                ) AND
                requested_at > (CURRENT_TIMESTAMP() - ?)
            ', array_merge(
                $artists,
                [config('shoutzor.artistRequestDelay')]
            ))
            ->orderBy('requested_at', 'DESC')
            ->limit(1)
            ->first();

        // If no results are found, the artist is requestable
        return !$recent;
    }
}
