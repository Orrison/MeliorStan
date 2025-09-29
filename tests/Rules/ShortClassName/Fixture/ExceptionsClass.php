<?php

class A {} // Exception - should be valid

class B {} // Exception - should be valid

class C {} // Too short

class ValidClassName {}

interface I {} // Exception - should be valid

trait T {} // Exception - should be valid

enum E {} // Exception - should be valid