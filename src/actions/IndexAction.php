<?php
namespace sagebind\blog\actions;

use Icicle\Http\Message\{BasicResponse, Request};
use Icicle\Stream\MemorySink;

class IndexAction extends Action
{
    public function handle(Request $request, array $args): \Generator
    {
        $html = $this->app->getRenderer()->render('index', [
            'articles' => new \LimitIterator($this->app->getArticleStore()->getIterator(), 0, 3),
        ]);

        $sink = new MemorySink();
        yield from $sink->end($html);

        return new BasicResponse(200, [
            'Content-Type' => 'text/html',
            'Content-Length' => $sink->getLength(),
        ], $sink);
    }
}
