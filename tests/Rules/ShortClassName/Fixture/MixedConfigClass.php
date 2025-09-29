<?php

class A {} // Exception - should be valid even with minimum 5

class B {} // Too short

class ValidClassName {}

interface I {} // Exception - should be valid

class ShortName {} // Too short with minimum 10
