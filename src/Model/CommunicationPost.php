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
use Base3\CommunicationFoundation\Api\ICommunicationPostMedia;
use Base3\CommunicationFoundation\Exception\CommunicationValidationException;

/**
 * Default immutable implementation of a platform-neutral communication post.
 *
 * This model represents only the logical post content and deliberately avoids
 * provider-specific publication details. It can therefore be reused across
 * different communication providers such as Tumblr, Mastodon, LinkedIn or
 * other future integrations.
 *
 * The class stores an optional title, an optional caption, an optional link,
 * a list of provider-neutral tags, an ordered list of media objects and an
 * optional language identifier.
 *
 * The constructor validates the structural integrity of the provided arrays in
 * order to guarantee that consuming publishers can rely on a predictable data
 * shape.
 */
class CommunicationPost implements ICommunicationPost
{
	private ?string $title;

	private ?string $caption;

	private ?string $link;

	/**
	 * @var array<int, string>
	 */
	private array $tags;

	/**
	 * @var array<int, ICommunicationPostMedia>
	 */
	private array $media;

	private ?string $language;

	/**
	 * Creates a new immutable communication post model.
	 *
	 * The given arrays are validated but otherwise preserved in their original
	 * order. This is especially important for media objects because their list
	 * order may be semantically relevant for the final rendered post.
	 *
	 * @param string|null $title
	 * Optional title of the post.
	 *
	 * @param string|null $caption
	 * Optional main text body of the post.
	 *
	 * @param string|null $link
	 * Optional associated URL of the post.
	 *
	 * @param array<int, string> $tags
	 * Provider-neutral ordered tag list.
	 *
	 * @param array<int, ICommunicationPostMedia> $media
	 * Ordered list of media items attached to the post.
	 *
	 * @param string|null $language
	 * Optional language or locale identifier of the post.
	 *
	 * @throws CommunicationValidationException
	 * Thrown if tags or media contain invalid values.
	 */
	public function __construct(
		?string $title = null,
		?string $caption = null,
		?string $link = null,
		array $tags = [],
		array $media = [],
		?string $language = null
	) {
		$this->title = $title;
		$this->caption = $caption;
		$this->link = $link;
		$this->tags = self::validateTags($tags);
		$this->media = self::validateMedia($media);
		$this->language = $language;
	}

	/**
	 * Returns the optional title of the post.
	 *
	 * @return string|null
	 * Returns the title or null if no title is defined.
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 * Returns the optional caption of the post.
	 *
	 * @return string|null
	 * Returns the caption or null if no caption is defined.
	 */
	public function getCaption(): ?string
	{
		return $this->caption;
	}

	/**
	 * Returns the optional link of the post.
	 *
	 * @return string|null
	 * Returns the link or null if no link is defined.
	 */
	public function getLink(): ?string
	{
		return $this->link;
	}

	/**
	 * Returns the provider-neutral ordered tag list.
	 *
	 * @return array<int, string>
	 * Returns the validated ordered tag list.
	 */
	public function getTags(): array
	{
		return $this->tags;
	}

	/**
	 * Returns the ordered media objects of the post.
	 *
	 * @return array<int, ICommunicationPostMedia>
	 * Returns the validated ordered media list.
	 */
	public function getMedia(): array
	{
		return $this->media;
	}

	/**
	 * Returns the optional language identifier of the post.
	 *
	 * @return string|null
	 * Returns the language code or null if no language is defined.
	 */
	public function getLanguage(): ?string
	{
		return $this->language;
	}

	/**
	 * Validates the given tag list.
	 *
	 * The method checks only the structural integrity of the array and does not
	 * enforce provider-specific formatting rules. Normalization such as adding
	 * hashtag prefixes belongs into provider implementations and not into the
	 * generic foundation model.
	 *
	 * @param array<int, mixed> $tags
	 * Raw tag list to validate.
	 *
	 * @return array<int, string>
	 * Returns the validated tag list.
	 *
	 * @throws CommunicationValidationException
	 * Thrown if at least one tag is not a string.
	 */
	private static function validateTags(array $tags): array
	{
		$result = [];

		foreach ($tags as $index => $tag) {
			if (!is_string($tag)) {
				throw new CommunicationValidationException(
					sprintf('Invalid tag at index %d. Expected string.', $index)
				);
			}

			$result[] = $tag;
		}

		return $result;
	}

	/**
	 * Validates the given media list.
	 *
	 * The method verifies that every entry implements the required media
	 * contract so that publishers can safely consume the collection later.
	 *
	 * @param array<int, mixed> $media
	 * Raw media list to validate.
	 *
	 * @return array<int, ICommunicationPostMedia>
	 * Returns the validated media list.
	 *
	 * @throws CommunicationValidationException
	 * Thrown if at least one media entry does not implement the required
	 * media interface.
	 */
	private static function validateMedia(array $media): array
	{
		$result = [];

		foreach ($media as $index => $item) {
			if (!$item instanceof ICommunicationPostMedia) {
				throw new CommunicationValidationException(
					sprintf('Invalid media item at index %d. Expected instance of ICommunicationPostMedia.', $index)
				);
			}

			$result[] = $item;
		}

		return $result;
	}
}
