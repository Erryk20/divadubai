<?php
namespace app\traits;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Sergiy
 */
trait TypeVideo {

    public static function getTypeVideo($video_id) {

        if (preg_match('/^\d+$/', trim($video_id), $match)) {
            return [
                'type' => 'vimeo',
                'id' => $match[0],
                'src' => "/images/user-media/{$video_id}",
            ];
        }

        if (preg_match('/^[\w|\-]+$/', trim($video_id), $match)) {
            return [
                'type' => 'youtube',
                'id' => $match[0],
                'src' => "/images/user-media/{$video_id}",
            ];
        }
    }

}
