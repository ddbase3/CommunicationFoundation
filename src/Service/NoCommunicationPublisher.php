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

namespace Base3\CommunicationFoundation\Service;

use Base3\CommunicationFoundation\Api\ICommunicationPublishRequest;
use Base3\CommunicationFoundation\Api\ICommunicationPublishResult;
use Base3\CommunicationFoundation\Api\ICommunicationPublisher;
use Base3\CommunicationFoundation\Model\CommunicationPublishResult;

/**
 * Publisher implementation that intentionally performs no publish action.
 *
 * This class can be used as a safe fallback in environments where the
 * publisher contract must be fulfilled but no concrete provider is configured.
 */
class NoCommunicationPublisher implements ICommunicationPublisher {

	/**
	 * Publishes the given communication request.
	 *
	 * This implementation intentionally does nothing and returns a normalized
	 * result that indicates that no real publisher is configured.
	 *
	 * @param ICommunicationPublishRequest $request
	 * The request that would normally be published.
	 *
	 * @return ICommunicationPublishResult
	 * Returns a normalized no-op publish result.
	 */
	public function publish(ICommunicationPublishRequest $request): ICommunicationPublishResult {
		return new CommunicationPublishResult(
			false,
			null,
			null,
			null,
			'No communication publisher configured.',
			[
				'publisher' => 'none',
				'mode' => 'noop'
			]
		);
	}
}
