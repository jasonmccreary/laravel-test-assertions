<?php

namespace JMac\Testing\Comparators;

use Closure;
use SebastianBergmann\Comparator\Comparator;

/**
 * Treats any two closures as equal.
 *
 * PHPUnit 12 added SebastianBergmann\Comparator\ClosureComparator, which only
 * considers closures equal when their declaration matches -- same file name and
 * same start and end line. Validation rules routinely contain closures, and the
 * expected closure is declared in the test while the actual one is declared in
 * the form request, so that check can never pass.
 *
 * On PHPUnit 11 there was no such comparator. Closures fell through to the
 * object comparator and compared equal because a Closure exposes no properties,
 * so the assertion never actually inspected them. This comparator keeps that
 * behavior explicit rather than relying on the absence of a comparator.
 *
 * PHP offers no way to compare two closures by behavior, so an assertion can
 * only establish that a closure is present in a given position. Tests that need
 * to pin down what a closure does should extract it from rules() and cover it
 * separately.
 */
final class ClosuresAreEqualComparator extends Comparator
{
    public function accepts(mixed $expected, mixed $actual): bool
    {
        return $expected instanceof Closure && $actual instanceof Closure;
    }

    public function assertEquals(mixed $expected, mixed $actual, float $delta = 0.0, bool $canonicalize = false, bool $ignoreCase = false): void
    {
        // Two closures always compare equal; there is nothing to report.
    }
}
