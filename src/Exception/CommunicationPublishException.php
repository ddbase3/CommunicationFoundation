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

use Throwable;

/**
 * Exception thrown when a concrete communication publisher fails to publish
 * content to a target provider.
 *
 * This exception type is intended for operational publish failures such as
 * rejected provider requests, upload failures, authentication issues or other
 * provider-specific runtime problems.
 *
 * In addition to the exception message, the class can store normalized context
 * data that may help with logging, diagnostics or higher-level error handling.
 */
class CommunicationPublishException extends CommunicationException
{
	/**
	 * @var array<string, mixed>
	 */
	private array $context;

	/**
	 * Creates a new communication publish exception.
	 *
	 * @param string $message
	 * Human-readable publish error message.
	 *
	 * @param array<string, mixed> $context
	 * Optional normalized diagnostic context.
	 *
	 * @param int $code
	 * Optional exception code.
	 *
	 * @param Throwable|null $previous
	 * Optional previous exception for chaining.
	 *
	 * @throws CommunicationValidationException
	 * Thrown if the context map is not keyed by strings.
	 */
	public function __construct(
		string $message = '',
		array $context = [],
		int $code = 0,
		?Throwable $previous = null
	) {
		parent::__construct($message, $code, $previous);

		$this->context = self::validateContext($context);
	}

	/**
	 * Returns the normalized diagnostic context of the publish failure.
	 *
	 * @return array<string, mixed>
	 * Returns the diagnostic context map.
	 */
	public function getContext(): array
	{
		return $this->context;
	}

	/**
	 * Validates the diagnostic context map.
	 *
	 * @param array<mixed, mixed> $context
	 * Raw diagnostic context to validate.
	 *
	 * @return array<string, mixed>
	 * Returns the validated diagnostic context map.
	 *
	 * @throws CommunicationValidationException
	 * Thrown if at least one context key is not a string.
	 */
	private static function validateContext(array $context): array
	{
		$result = [];

		foreach ($context as $key => $value) {
			if (!is_string($key)) {
				throw new CommunicationValidationException(
					'Invalid publish exception context key detected. Expected string keys only.'
				);
			}

			$result[$key] = $value;
		}

		return $result;
	}
}
