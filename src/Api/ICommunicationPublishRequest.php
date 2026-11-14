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

namespace Base3\CommunicationFoundation\Api;

use DateTimeInterface;

/**
 * Describes a concrete publication request for a communication post.
 *
 * This interface separates the actual post content from the delivery context.
 * A publish request defines where, when and under which conditions a given
 * post should be published.
 *
 * The same post may be wrapped in multiple publish requests in order to send
 * identical content to different targets, accounts or providers with different
 * scheduling or visibility settings.
 *
 * Provider-specific settings must not be mixed into the generic content model.
 * They are intentionally collected in a dedicated options structure so that
 * the core contract remains stable and reusable across multiple platforms.
 */
interface ICommunicationPublishRequest
{
	/**
	 * Returns the post content that should be published.
	 *
	 * This object contains the provider-neutral content payload including title,
	 * caption, tags and media. The publisher combines this content with the
	 * additional delivery metadata of the current request.
	 *
	 * @return ICommunicationPost
	 * Returns the post content to publish.
	 */
	public function getPost(): ICommunicationPost;

	/**
	 * Returns the logical publication target.
	 *
	 * This identifies the destination account, blog, page, profile, channel or
	 * any other provider-specific publication target. The exact meaning depends
	 * on the target provider, but the contract stays intentionally generic so it
	 * can be reused for many platforms.
	 *
	 * Publishers may require this value even if the interface allows null.
	 * Allowing null keeps the contract flexible for implementations that inject
	 * the target through configuration or context instead of the request object.
	 *
	 * @return string|null
	 * Returns the target identifier or null if no explicit target is defined.
	 */
	public function getTarget(): ?string;

	/**
	 * Returns the optional planned publication time.
	 *
	 * If a value is present, publishers may use it for scheduled publishing when
	 * supported by the provider. If the provider does not support scheduling,
	 * implementations may either publish immediately, reject the request or
	 * delegate scheduling to a higher application layer.
	 *
	 * @return DateTimeInterface|null
	 * Returns the planned publication time or null for immediate publishing.
	 */
	public function getPublishAt(): ?DateTimeInterface;

	/**
	 * Returns the optional external identifier of the parent post.
	 *
	 * This is useful for replies, repost chains, comment-like systems, threaded
	 * posts or provider-specific parent-child relations. The exact semantics are
	 * determined by the target provider.
	 *
	 * @return string|null
	 * Returns the external parent identifier or null if the request is not a
	 * reply or child post.
	 */
	public function getReplyToExternalId(): ?string;

	/**
	 * Returns the optional visibility setting of the publication request.
	 *
	 * Typical values may include identifiers such as "public", "private",
	 * "unlisted", "draft" or "friends-only". The concrete allowed values are
	 * intentionally not hardcoded into the contract because providers differ
	 * significantly in their visibility models.
	 *
	 * A publisher may ignore unsupported values, normalize them or reject the
	 * request according to its own validation strategy.
	 *
	 * @return string|null
	 * Returns the visibility identifier or null if no explicit visibility is
	 * defined.
	 */
	public function getVisibility(): ?string;

	/**
	 * Returns provider-specific publishing options.
	 *
	 * This method acts as an extension point for settings that are required only
	 * by certain providers and that should therefore not become part of the
	 * generic core contract. Examples may include queue options, platform states,
	 * special publish flags or feature toggles supported by a specific provider.
	 *
	 * The returned structure should contain normalized option keys and values
	 * that can be interpreted by the matching publisher implementation.
	 *
	 * @return array<string, mixed>
	 * Returns the provider-specific option map.
	 */
	public function getProviderOptions(): array;
}
