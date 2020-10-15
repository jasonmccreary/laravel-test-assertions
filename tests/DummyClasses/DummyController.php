<?php

namespace Dummy;

use Illuminate\Routing\Controller;

class DummyController extends Controller {
    public function test() {
        return 'test response';
    }
}