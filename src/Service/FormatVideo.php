<?php

namespace App\Service;

class FormatVideo
{
    public function formatVideoDatasFromUrl(string $url): array|false
    {
        $videoDatas = [];
        $isYoutube = str_contains($url, 'youtube');
        $isDailymotion = str_contains($url, 'dailymotion');

        if ($isYoutube | $isDailymotion) {
            if ($isYoutube) {
                $videoDatas['url'] = str_replace('watch?v=', 'embed/', $url);
                $separatedLinkElements = explode('/', $videoDatas['url']);
                $videoDatas['thumbnail'] = 'https://img.youtube.com/vi/'.end($separatedLinkElements).'/0.jpg';
            }
            if ($isDailymotion) {
                $videoDatas['url'] = str_replace('video', 'embed/video', $url);
                $separatedLinkElements = explode('/', $videoDatas['url']);
                $videoDatas['thumbnail'] = 'https://www.dailymotion.com/thumbnail/video/'.end($separatedLinkElements);
            }

            return $videoDatas;
        }

        return false;
    }
}
