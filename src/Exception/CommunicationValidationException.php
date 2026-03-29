<?php declare(strict_types=1);

/***********************************************************************
 * This file is part of CommunicationFoundation for BASE3 Framework.
 *
 * CommunicationFoundation extends the BASE3 framework with a shared API
 * foundation for platform-neutral publishing, outbound communication,
 * and reusable content delivery contracts across providers.
 *
 * Developed by Daniel Dahme
 * Licensed under GPL-3.0
 * https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * https://base3.de/v/communicationfoundation
 * https://github.com/ddbase3/CommunicationFoundation
 **********************************************************************/

namespace CommunicationFoundation\Exception;

use Throwable;

/**
 * Exception thrown when communication models receive structurally invalid
 * input data.
 *
 * This exception is intended for validation errors inside the provider-neutral
 * foundation layer, for example invalid array contents, malformed option maps
 * or incompatible model objects.
 */
class CommunicationValidationException extends CommunicationException
{
	/**
	 * Creates a new communication validation exception.
	 *
	 * @param string $message
	 * Human-readable validation error message.
	 *
	 * @param int $code
	 * Optional exception code.
	 *
	 * @param Throwable|null $previous
	 * Optional previous exception for chaining.
	 */
	public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}
