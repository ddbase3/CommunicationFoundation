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

namespace Base3\CommunicationFoundation\Exception;

use RuntimeException;
use Throwable;

/**
 * Base exception for the CommunicationFoundation plugin.
 *
 * All communication-related exceptions should extend this class so that higher
 * application layers can catch one common base type for all communication
 * errors, regardless of whether they are caused by validation, publishing or
 * provider-specific integration logic.
 */
class CommunicationException extends RuntimeException
{
	/**
	 * Creates a new communication exception.
	 *
	 * @param string $message
	 * Human-readable exception message.
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
