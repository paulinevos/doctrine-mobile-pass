<?php

namespace Vos\DoctrineMobilePass\Exceptions;

use Illuminate\Validation\ValidationException;

class InvalidPass extends ValidationException implements MobilePassException {}
