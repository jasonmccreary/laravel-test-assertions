<?php

namespace Tests;

use Illuminate\Routing\Controller;

class DummyController extends Controller {
    public function test() {
        return 'test response';
    }
}