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

use Base3\CommunicationFoundation\Api\ICommunicationPostMedia;

/**
 * Default immutable implementation of a media item attached to a
 * communication post.
 *
 * This model stores only provider-neutral metadata about a single media
 * asset. The actual interpretation of the data depends on the concrete
 * publisher implementation and the capabilities of the target platform.
 *
 * The source may point to a local file path or to a remote URL. The model
 * itself does not enforce how the source is resolved or uploaded.
 */
class CommunicationPostMedia implements ICommunicationPostMedia
{
	private string $source;

	private string $type;

	private ?string $mimeType;

	private ?string $title;

	private ?string $altText;

	private int $sortOrder;

	private ?string $thumbnailSource;

	/**
	 * Creates a new immutable communication post media model.
	 *
	 * @param string $source
	 * Local file path or remote URL of the media asset.
	 *
	 * @param string $type
	 * Logical media type such as image or video.
	 *
	 * @param string|null $mimeType
	 * Optional MIME type of the media asset.
	 *
	 * @param string|null $title
	 * Optional media-specific title.
	 *
	 * @param string|null $altText
	 * Optional alternative text for accessibility.
	 *
	 * @param int $sortOrder
	 * Intended sort order of the media item.
	 *
	 * @param string|null $thumbnailSource
	 * Optional local file path or remote URL of a preview image.
	 */
	public function __construct(
		string $source,
		string $type,
		?string $mimeType = null,
		?string $title = null,
		?string $altText = null,
		int $sortOrder = 0,
		?string $thumbnailSource = null
	) {
		$this->source = $source;
		$this->type = $type;
		$this->mimeType = $mimeType;
		$this->title = $title;
		$this->altText = $altText;
		$this->sortOrder = $sortOrder;
		$this->thumbnailSource = $thumbnailSource;
	}

	/**
	 * Returns the media source.
	 *
	 * @return string
	 * Returns the local file path or remote URL of the media asset.
	 */
	public function getSource(): string
	{
		return $this->source;
	}

	/**
	 * Returns the logical media type.
	 *
	 * @return string
	 * Returns the logical media type.
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * Returns the optional MIME type.
	 *
	 * @return string|null
	 * Returns the MIME type or null if it is not defined.
	 */
	public function getMimeType(): ?string
	{
		return $this->mimeType;
	}

	/**
	 * Returns the optional media title.
	 *
	 * @return string|null
	 * Returns the title or null if no title is defined.
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 * Returns the optional alternative text of the media item.
	 *
	 * @return string|null
	 * Returns the alt text or null if no alt text is defined.
	 */
	public function getAltText(): ?string
	{
		return $this->altText;
	}

	/**
	 * Returns the intended sort order of the media item.
	 *
	 * @return int
	 * Returns the sort order.
	 */
	public function getSortOrder(): int
	{
		return $this->sortOrder;
	}

	/**
	 * Returns the optional thumbnail source of the media item.
	 *
	 * @return string|null
	 * Returns the thumbnail source or null if no thumbnail is defined.
	 */
	public function getThumbnailSource(): ?string
	{
		return $this->thumbnailSource;
	}
}
