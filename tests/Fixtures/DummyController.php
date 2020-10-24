<?php

namespace Tests\Fixtures;

use Illuminate\Routing\Controller;

class DummyController extends Controller {

    public function test(DummyRequest $request) {
        return 'test response';
    }
}