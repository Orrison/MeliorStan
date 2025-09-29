<?php

class ValidClassName {}

class AB {} // Too short

class A {} // Too short

class Cd {} // Valid

interface AB {} // Too short

trait A {} // Too short

enum N {} // Too short

class LongEnoughClassName {} // Valid
interface LongEnoughInterface {} // Valid
trait LongEnoughTrait {} // Valid
enum LongEnoughEnum {} // Valid