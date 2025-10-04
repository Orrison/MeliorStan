<?php

namespace Orrison\MeliorStan\Tests\Rules\NumberOfChildren\Fixture;

class ParentWithThreeChildren {}

class ChildOne extends ParentWithThreeChildren {}

class ChildTwo extends ParentWithThreeChildren {}

class ChildThree extends ParentWithThreeChildren {}

class ParentWithOneChild {}

class OnlyChild extends ParentWithOneChild {}

class ParentWithNoChildren {}

class GrandParent {}

class Parent1 extends GrandParent {}

class Parent2 extends GrandParent {}

class GrandChild1 extends Parent1 {}

class GrandChild2 extends Parent1 {}
