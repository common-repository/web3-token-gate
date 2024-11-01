import React from 'react';

import { Card, CardBody } from '@wordpress/components';

function Instructions() {
	return (
		<Card>
			<CardBody>
				<h2>✅ Verify NFT Ownership</h2>
				<p>
					Please follow the steps below to verify the ownership of
					your NFT and display results on your website:
				</p>
				<ul>
					<li>
						<strong>Step 1:</strong> Store Your NFT Address below
						for verification
					</li>
					<li>
						<strong>Step 2:</strong> Use the{ ' ' }
						<code>[token-gate-verify-app]</code> shortcode to render
						the verification app.
					</li>
					<li>
						<strong>Step 3:</strong> Use the{ ' ' }
						<code>[token-gate-output]</code> to render the
						verification results.
					</li>
				</ul>

				<hr />

				<p>
					<strong>Note: </strong>
					Web3 Token Gate only works on <strong>Ethereum</strong> main
					net. Therefore, Please use an <strong>Ethereum NFT</strong>{ ' ' }
					when using Web3 Token Gate.
				</p>
			</CardBody>
		</Card>
	);
}

export default Instructions;
