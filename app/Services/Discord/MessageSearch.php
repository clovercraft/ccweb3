<?php

namespace App\Services\Discord;

class MessageSearch
{

    private string $channel;
    private string $author;
    private int $pages = 0;
    private int $max_pages = 20;

    public function __construct(string $channel, string $author)
    {
        $this->channel = $channel;
        $this->author = $author;
    }

    public function search($before = null)
    {
        return $this->pageMessages();
    }

    private function pageMessages($before = null)
    {
        $last = null;
        $messages = $this->getMessages($before);
        foreach ($messages as $message) {
            $author = $message['author']['id'];
            if ($author == $this->author) {
                return $message;
            }
            $last = $message['id'];
        }
        $this->pages++;
        if ($this->pages >= $this->max_pages) {
            return false;
        } else {
            return $this->pageMessages($last);
        }
    }

    private function getMessages($before = null)
    {
        $call = $response = ApiCall::endpoint(sprintf("/channels/%s/messages", $this->channel))
            ->asBot();

        if ($before !== null) {
            $response = $call->withParams([
                'before' => $before
            ])->get();
        } else {
            $response = $call->get();
        }

        return $response;
    }
}
