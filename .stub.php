<?php

namespace Illuminate\Testing {
    class TestResponse
    {
        /**
         * Assert that the response view has a given piece
         * of bound data and its value is `null`.
         */
        public function assertViewHasNull(string $key): static {}
    }
}
