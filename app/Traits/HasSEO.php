<?php

namespace App\Traits;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

trait HasSEO
{
    protected function setSEO(array $data)
    {
        if (isset($data['title'])) {
            SEOMeta::setTitle($data['title']);
            OpenGraph::setTitle($data['title']);
            TwitterCard::setTitle($data['title']);
        }

        if (isset($data['description'])) {
            SEOMeta::setDescription($data['description']);
            OpenGraph::setDescription($data['description']);
            TwitterCard::setDescription($data['description']);
        }

        if (isset($data['url'])) {
            SEOMeta::setCanonical($data['url']);
            OpenGraph::setUrl($data['url']);
        }

        if (isset($data['image'])) {
            OpenGraph::addImage($data['image']);
            TwitterCard::setImage($data['image']);
        }

        if (isset($data['keywords'])) {
            SEOMeta::setKeywords($data['keywords']);
        }
    }
}