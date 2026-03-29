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
 * Publishes communication posts to a concrete target provider.
 *
 * Implementations of this interface are responsible for transforming the
 * generic communication contracts into provider-specific API calls, request
 * payloads and upload operations.
 *
 * A publisher usually represents one concrete integration, for example a
 * Tumblr publisher, a Mastodon publisher or a LinkedIn publisher. The contract
 * itself stays provider-neutral so that higher application layers can work
 * against a unified abstraction.
 *
 * Implementations are expected to validate the request according to the rules
 * and limitations of the target platform and to return a normalized publish
 * result object describing the outcome.
 */
interface ICommunicationPublisher
{
	/**
	 * Publishes the given communication request.
	 *
	 * The implementation should convert the generic post and request metadata
	 * into the provider-specific publication workflow, including optional media
	 * uploads, text transformation, tag mapping, scheduling and error handling.
	 *
	 * The method returns a normalized result object so that calling code can
	 * react to success and failure states in a provider-independent way.
	 *
	 * @param ICommunicationPublishRequest $request
	 * The fully prepared request that should be published.
	 *
	 * @return ICommunicationPublishResult
	 * Returns the normalized result of the publication attempt.
	 */
	public function publish(ICommunicationPublishRequest $request): ICommunicationPublishResult;
}
