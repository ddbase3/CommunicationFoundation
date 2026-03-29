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

namespace CommunicationFoundation\Api;

/**
 * Describes the platform-neutral content of a communication post.
 *
 * This interface intentionally models only the post content itself and not
 * its delivery target or publication settings. The same post content may be
 * published to different providers, accounts, blogs, pages or channels.
 *
 * A post may contain plain text, a title, a link and an ordered list of media
 * objects. Tags are represented in a provider-neutral way so that concrete
 * publishers can decide how to map them to hashtags, labels or native tagging
 * systems of the target platform.
 *
 * Implementations should keep this contract free from provider-specific
 * details. Any provider-specific delivery options belong into the publish
 * request and not into the content model itself.
 */
interface ICommunicationPost
{
	/**
	 * Returns the optional title of the post.
	 *
	 * Not every provider supports titles directly, but some platforms, blog-like
	 * systems or internal renderers may use it. Publishers that do not support
	 * titles can ignore this value or merge it into the caption according to
	 * their own rules.
	 *
	 * @return string|null
	 * Returns the title text or null if no title is defined.
	 */
	public function getTitle(): ?string;

	/**
	 * Returns the main textual body of the post.
	 *
	 * This is the primary human-readable content that will usually become the
	 * visible text, caption, description or body of the published post.
	 *
	 * The returned value should be considered plain content input. Concrete
	 * publishers may transform or truncate it if the target platform requires
	 * a different format or enforces length limitations.
	 *
	 * @return string|null
	 * Returns the caption text or null if no caption is defined.
	 */
	public function getCaption(): ?string;

	/**
	 * Returns the optional link associated with the post.
	 *
	 * This may point to a canonical source, landing page, article, product page
	 * or any other relevant external destination. A provider may use this value
	 * directly, append it to the caption or ignore it if the platform does not
	 * support links in a meaningful way.
	 *
	 * @return string|null
	 * Returns the link URL or null if no link is defined.
	 */
	public function getLink(): ?string;

	/**
	 * Returns the platform-neutral tags of the post.
	 *
	 * These tags are intentionally not restricted to a single concrete syntax.
	 * A publisher may render them as hashtags, plain tags, metadata labels or
	 * any other provider-specific tagging mechanism.
	 *
	 * The returned list should contain only the logical tag values without any
	 * provider-specific formatting assumptions. For example, a tag may be stored
	 * as "ballet" instead of "#ballet", leaving the final rendering to the
	 * publisher implementation.
	 *
	 * @return array<int, string>
	 * Returns an ordered list of normalized tag values.
	 */
	public function getTags(): array;

	/**
	 * Returns the media objects attached to the post.
	 *
	 * The list may contain images, videos or other supported media types,
	 * depending on the capabilities of the concrete provider implementation.
	 * The order of the returned items is significant and should represent the
	 * intended display order of the media within the post.
	 *
	 * Implementations should return a stable ordered collection. Publishers may
	 * still need to reorder, filter or reject media items if the target platform
	 * imposes provider-specific restrictions.
	 *
	 * @return array<int, ICommunicationPostMedia>
	 * Returns the ordered list of media objects.
	 */
	public function getMedia(): array;

	/**
	 * Returns the optional language identifier of the post content.
	 *
	 * This value can be used by publishers for provider-specific metadata,
	 * localization, accessibility, routing or content selection. The expected
	 * format is typically a normalized language or locale code such as "en",
	 * "de" or "en-US", but the concrete validation strategy is left to the
	 * implementation layer.
	 *
	 * @return string|null
	 * Returns the language code or null if no language is defined.
	 */
	public function getLanguage(): ?string;
}
