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

use DateTimeInterface;

/**
 * Describes the normalized result of a publication attempt.
 *
 * This interface provides a provider-neutral view of the publication outcome.
 * It allows higher application layers to inspect whether the publishing
 * process succeeded and to access common result data such as external IDs,
 * URLs, timestamps and normalized raw response data.
 *
 * Concrete providers often return very different response structures. This
 * contract exists to expose the most important common information while still
 * preserving a structured escape hatch for debugging and logging.
 */
interface ICommunicationPublishResult
{
	/**
	 * Returns whether the publication attempt was successful.
	 *
	 * A successful result usually means that the provider accepted the request
	 * and returned a meaningful external identifier or another confirmation that
	 * the post now exists remotely or has been scheduled successfully.
	 *
	 * @return bool
	 * Returns true if the publish operation succeeded, otherwise false.
	 */
	public function isSuccess(): bool;

	/**
	 * Returns the external identifier created by the provider.
	 *
	 * This identifier can be used for later follow-up operations such as update,
	 * delete, lookup, reply linking or synchronization.
	 *
	 * @return string|null
	 * Returns the external provider identifier or null if none is available.
	 */
	public function getExternalId(): ?string;

	/**
	 * Returns the external URL of the published content.
	 *
	 * If the provider exposes a public or internal URL for the published post,
	 * this method should return it. Some providers do not return a URL directly,
	 * in which case implementations may return null.
	 *
	 * @return string|null
	 * Returns the external post URL or null if no URL is available.
	 */
	public function getExternalUrl(): ?string;

	/**
	 * Returns the effective publication timestamp.
	 *
	 * This may represent the actual publication time or the accepted scheduling
	 * time, depending on provider behavior and the meaning of the result.
	 *
	 * @return DateTimeInterface|null
	 * Returns the publication timestamp or null if it is unknown.
	 */
	public function getPublishedAt(): ?DateTimeInterface;

	/**
	 * Returns a human-readable error message if the publication failed.
	 *
	 * The message should be normalized enough to be useful for application logs,
	 * diagnostics or user-facing feedback. On successful publication attempts,
	 * this method should usually return null.
	 *
	 * @return string|null
	 * Returns the error message or null if no error message is available.
	 */
	public function getErrorMessage(): ?string;

	/**
	 * Returns normalized raw provider response data.
	 *
	 * This method is intended for logging, diagnostics, debugging and advanced
	 * provider-specific follow-up logic. The returned structure should be safe
	 * to inspect programmatically without forcing calling code to know the exact
	 * shape of the original provider response object.
	 *
	 * @return array<string, mixed>
	 * Returns the normalized raw provider result data.
	 */
	public function getRawResult(): array;
}
