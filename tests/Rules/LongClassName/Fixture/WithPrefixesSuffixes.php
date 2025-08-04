<?php

// With subtract_prefixes: ["Abstract", "Test"] and subtract_suffixes: ["Interface", "Impl"]
// Maximum: 20

// Should pass because "Abstract" prefix is subtracted (20 - 8 = 12 effective chars)
class AbstractVeryLongClassName {}

// Should pass because "Interface" suffix is subtracted (23 - 9 = 14 effective chars) 
class VeryLongClassInterface {}

// Should pass because "Impl" suffix is subtracted (16 - 4 = 12 effective chars)
class VeryLongClassImpl {}

// Should pass because "Test" prefix is subtracted (16 - 4 = 12 effective chars)
class TestVeryLongClass {}

// Should fail - no prefix/suffix subtraction applies (21 > 20)
class VeryLongClassNameHere {}

// Should pass - both prefix and suffix, but only first matching is subtracted
// "Abstract" prefix subtracted (28 - 8 = 20 = maximum)
class AbstractVeryLongClassInterface {}