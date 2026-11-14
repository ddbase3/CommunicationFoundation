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

namespace Base3\CommunicationFoundation\Model;

use Base3\CommunicationFoundation\Api\ICommunicationPost;
use Base3\CommunicationFoundation\Api\ICommunicationPublishRequest;
use Base3\CommunicationFoundation\Exception\CommunicationValidationException;
use DateTimeInterface;

/**
 * Default immutable implementation of a communication publish request.
 *
 * This model combines a platform-neutral post object with the publication
 * context required to deliver it to a concrete provider. It therefore
 * separates content from delivery metadata such as target, scheduling,
 * reply context, visibility and provider-specific options.
 *
 * The class is designed to be reusable across multiple providers and keeps
 * provider-specific extension data in a dedicated option map.
 */
class CommunicationPublishRequest implements ICommunicationPublishRequest
{
	private ICommunicationPost $post;

	private ?string $target;

	private ?DateTimeInterface $publishAt;

	private ?string $replyToExternalId;

	private ?string $visibility;

	/**
	 * @var array<string, mixed>
	 */
	private array $providerOptions;

	/**
	 * Creates a new immutable publish request.
	 *
	 * @param ICommunicationPost $post
	 * Provider-neutral post content that should be published.
	 *
	 * @param string|null $target
	 * Optional logical target identifier such as blog, account, page or channel.
	 *
	 * @param DateTimeInterface|null $publishAt
	 * Optional planned publication timestamp.
	 *
	 * @param string|null $replyToExternalId
	 * Optional provider-specific parent or reply identifier.
	 *
	 * @param string|null $visibility
	 * Optional visibility identifier.
	 *
	 * @param array<string, mixed> $providerOptions
	 * Provider-specific option map.
	 *
	 * @throws CommunicationValidationException
	 * Thrown if provider options are not keyed by strings.
	 */
	public function __construct(
		ICommunicationPost $post,
		?string $target = null,
		?DateTimeInterface $publishAt = null,
		?string $replyToExternalId = null,
		?string $visibility = null,
		array $providerOptions = []
	) {
		$this->post = $post;
		$this->target = $target;
		$this->publishAt = $publishAt;
		$this->replyToExternalId = $replyToExternalId;
		$this->visibility = $visibility;
		$this->providerOptions = self::validateProviderOptions($providerOptions);
	}

	/**
	 * Returns the post content that should be published.
	 *
	 * @return ICommunicationPost
	 * Returns the post content model.
	 */
	public function getPost(): ICommunicationPost
	{
		return $this->post;
	}

	/**
	 * Returns the optional publication target.
	 *
	 * @return string|null
	 * Returns the target identifier or null if no explicit target is defined.
	 */
	public function getTarget(): ?string
	{
		return $this->target;
	}

	/**
	 * Returns the optional planned publication timestamp.
	 *
	 * @return DateTimeInterface|null
	 * Returns the planned publication time or null if immediate publication is
	 * intended.
	 */
	public function getPublishAt(): ?DateTimeInterface
	{
		return $this->publishAt;
	}

	/**
	 * Returns the optional parent or reply identifier.
	 *
	 * @return string|null
	 * Returns the external parent identifier or null if the request is not a
	 * reply or child post.
	 */
	public function getReplyToExternalId(): ?string
	{
		return $this->replyToExternalId;
	}

	/**
	 * Returns the optional visibility setting.
	 *
	 * @return string|null
	 * Returns the visibility identifier or null if none is defined.
	 */
	public function getVisibility(): ?string
	{
		return $this->visibility;
	}

	/**
	 * Returns the provider-specific option map.
	 *
	 * @return array<string, mixed>
	 * Returns the validated provider option map.
	 */
	public function getProviderOptions(): array
	{
		return $this->providerOptions;
	}

	/**
	 * Validates the provider-specific option map.
	 *
	 * The method guarantees that the option structure behaves like a true map
	 * with string keys, which is important for predictable downstream provider
	 * handling.
	 *
	 * @param array<mixed, mixed> $providerOptions
	 * Raw provider option map to validate.
	 *
	 * @return array<string, mixed>
	 * Returns the validated provider option map.
	 *
	 * @throws CommunicationValidationException
	 * Thrown if at least one option key is not a string.
	 */
	private static function validateProviderOptions(array $providerOptions): array
	{
		$result = [];

		foreach ($providerOptions as $key => $value) {
			if (!is_string($key)) {
				throw new CommunicationValidationException(
					'Invalid provider option key detected. Expected string keys only.'
				);
			}

			$result[$key] = $value;
		}

		return $result;
	}
}
