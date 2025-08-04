<?php

// These should fail with maximum: 20
class VeryLongClassNameThatExceeds {}
class AnotherVeryLongClassNameHere {}

// These should pass with maximum: 20  
class User {}
class ShortName {}
class Model {}
class AcceptableLengthName {}

interface LongInterfaceNameThatExceeds {}
trait VeryLongTraitNameThatExceeds {}
enum SuperLongEnumNameExceeds {}