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

namespace CommunicationFoundation\Model;

use CommunicationFoundation\Api\ICommunicationPublishResult;
use CommunicationFoundation\Exception\CommunicationValidationException;
use DateTimeInterface;

/**
 * Default immutable implementation of a normalized publish result.
 *
 * This model represents the outcome of a publication attempt in a
 * provider-neutral form. It intentionally exposes only the most relevant
 * common fields while still allowing providers to attach normalized raw
 * result data for logging and diagnostics.
 */
class CommunicationPublishResult implements ICommunicationPublishResult
{
	private bool $success;

	private ?string $externalId;

	private ?string $externalUrl;

	private ?DateTimeInterface $publishedAt;

	private ?string $errorMessage;

	/**
	 * @var array<string, mixed>
	 */
	private array $rawResult;

	/**
	 * Creates a new immutable publish result model.
	 *
	 * @param bool $success
	 * Defines whether the publish attempt succeeded.
	 *
	 * @param string|null $externalId
	 * Optional external identifier returned by the provider.
	 *
	 * @param string|null $externalUrl
	 * Optional URL of the published content.
	 *
	 * @param DateTimeInterface|null $publishedAt
	 * Optional effective publication timestamp.
	 *
	 * @param string|null $errorMessage
	 * Optional human-readable error message.
	 *
	 * @param array<string, mixed> $rawResult
	 * Normalized provider response data.
	 *
	 * @throws CommunicationValidationException
	 * Thrown if the raw result array is not keyed by strings.
	 */
	public function __construct(
		bool $success,
		?string $externalId = null,
		?string $externalUrl = null,
		?DateTimeInterface $publishedAt = null,
		?string $errorMessage = null,
		array $rawResult = []
	) {
		$this->success = $success;
		$this->externalId = $externalId;
		$this->externalUrl = $externalUrl;
		$this->publishedAt = $publishedAt;
		$this->errorMessage = $errorMessage;
		$this->rawResult = self::validateRawResult($rawResult);
	}

	/**
	 * Returns whether the publish operation succeeded.
	 *
	 * @return bool
	 * Returns true on success, otherwise false.
	 */
	public function isSuccess(): bool
	{
		return $this->success;
	}

	/**
	 * Returns the optional external provider identifier.
	 *
	 * @return string|null
	 * Returns the external identifier or null if none is available.
	 */
	public function getExternalId(): ?string
	{
		return $this->externalId;
	}

	/**
	 * Returns the optional external URL of the published content.
	 *
	 * @return string|null
	 * Returns the external URL or null if none is available.
	 */
	public function getExternalUrl(): ?string
	{
		return $this->externalUrl;
	}

	/**
	 * Returns the optional effective publication timestamp.
	 *
	 * @return DateTimeInterface|null
	 * Returns the publication timestamp or null if it is unknown.
	 */
	public function getPublishedAt(): ?DateTimeInterface
	{
		return $this->publishedAt;
	}

	/**
	 * Returns the optional human-readable error message.
	 *
	 * @return string|null
	 * Returns the error message or null if no error message is available.
	 */
	public function getErrorMessage(): ?string
	{
		return $this->errorMessage;
	}

	/**
	 * Returns the normalized raw provider result data.
	 *
	 * @return array<string, mixed>
	 * Returns the normalized raw result map.
	 */
	public function getRawResult(): array
	{
		return $this->rawResult;
	}

	/**
	 * Validates the normalized raw result map.
	 *
	 * The method ensures that the stored result behaves like a real string-keyed
	 * associative structure and can therefore be consumed reliably by callers.
	 *
	 * @param array<mixed, mixed> $rawResult
	 * Raw result data to validate.
	 *
	 * @return array<string, mixed>
	 * Returns the validated raw result map.
	 *
	 * @throws CommunicationValidationException
	 * Thrown if at least one raw result key is not a string.
	 */
	private static function validateRawResult(array $rawResult): array
	{
		$result = [];

		foreach ($rawResult as $key => $value) {
			if (!is_string($key)) {
				throw new CommunicationValidationException(
					'Invalid raw result key detected. Expected string keys only.'
				);
			}

			$result[$key] = $value;
		}

		return $result;
	}
}
