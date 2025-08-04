<?php

// Short names - should pass with default config (maximum: 40)
class User {}
class Repository {}
class VeryLongButStillWithinLimitsClassName {}

// Long names - should fail with default config
class ThisIsAnExtremelyLongClassNameThatExceedsTheDefaultMaximumLength {}

interface UserRepositoryInterface {}

trait AuthenticationTrait {}

enum UserStatus {}

// Even longer names
interface VeryVeryVeryLongInterfaceNameThatDefinitelyExceedsDefaultMaximum {}

trait ExtremelyLongTraitNameThatWillTriggerTheRule {}

enum SuperLongEnumNameThatShouldFailTheTestForSure {}