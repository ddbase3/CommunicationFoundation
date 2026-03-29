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
 * Describes a single media item attached to a communication post.
 *
 * A media object is intentionally platform-neutral and represents only the
 * metadata required to describe a media asset in a generic publishing context.
 * The concrete publisher is responsible for validating whether the given media
 * type, source format and metadata can actually be accepted by the target
 * provider.
 *
 * A media source may point to a local file path or to a remote URL. Publishers
 * may decide whether they support both variants or only one of them.
 *
 * The order of media items is defined outside of this interface by the list
 * returned from the post. The explicit sort order is still useful for stable
 * ordering, persistence and provider-specific transformations.
 */
interface ICommunicationPostMedia
{
	/**
	 * Returns the source location of the media asset.
	 *
	 * The source may be a local filesystem path or a remote URL. Concrete
	 * publishers are responsible for resolving, downloading, streaming or
	 * uploading the media according to their provider-specific requirements.
	 *
	 * @return string
	 * Returns the local file path or remote URL of the media asset.
	 */
	public function getSource(): string;

	/**
	 * Returns the logical media type.
	 *
	 * Expected values are usually generic identifiers such as "image" or
	 * "video". The exact vocabulary is intentionally kept flexible so that
	 * provider implementations can support additional media categories if
	 * required in the future.
	 *
	 * The value should describe the media semantically and not the technical
	 * transport format.
	 *
	 * @return string
	 * Returns the logical media type.
	 */
	public function getType(): string;

	/**
	 * Returns the optional MIME type of the media asset.
	 *
	 * This metadata can help publishers validate the asset or select the correct
	 * upload behavior. If the MIME type is not known in advance, implementations
	 * may return null and let the concrete publisher detect it later.
	 *
	 * @return string|null
	 * Returns the MIME type or null if it is unknown.
	 */
	public function getMimeType(): ?string;

	/**
	 * Returns the optional title of the media item.
	 *
	 * Some providers can display or store a separate title for a media asset.
	 * Others may ignore this value completely. The title is distinct from the
	 * post title and belongs only to the current media object.
	 *
	 * @return string|null
	 * Returns the media title or null if no title is defined.
	 */
	public function getTitle(): ?string;

	/**
	 * Returns the optional alternative text of the media item.
	 *
	 * Alt text is important for accessibility and may also be useful for search,
	 * indexing and provider-specific metadata. Publishers should pass this value
	 * to the target platform whenever the provider supports media-level alt text.
	 *
	 * @return string|null
	 * Returns the alt text or null if no alt text is defined.
	 */
	public function getAltText(): ?string;

	/**
	 * Returns the intended sort order of the media item.
	 *
	 * This numeric value can be used to keep media ordering stable across
	 * persistence layers, transformations and provider-specific upload steps.
	 * Lower values are typically expected to appear earlier than higher values.
	 *
	 * @return int
	 * Returns the sort order of the media item.
	 */
	public function getSortOrder(): int;

	/**
	 * Returns the optional thumbnail source of the media item.
	 *
	 * This is mainly useful for video content or for providers that support
	 * separate preview images. As with the main source, the returned value may
	 * be a local file path or a remote URL.
	 *
	 * @return string|null
	 * Returns the thumbnail source or null if no thumbnail is defined.
	 */
	public function getThumbnailSource(): ?string;
}
