<?php

namespace App\Processors;

use App\Upload;

class MediaProcessor {

    public function parse(Upload $upload) {

        //@TODO Do something with the media file in the temp upload directory

        //Debug only
        $path = storage_path('app/temp/upload/' . $upload->filename);
        unlink($path);
        die("job triggered!");
        //End:debug only

    }

}
