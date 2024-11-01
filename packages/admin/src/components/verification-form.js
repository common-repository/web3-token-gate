import { isEmpty } from 'lodash';
import * as ethers from 'ethers';
import { useState } from '@wordpress/element';
import { TextControl, Button, withNotices } from '@wordpress/components';

function VerificationForm( props ) {
	const [ isSaving, setSaving ] = useState( false );

	const onDataProcessRequest = async () => {
		try {
			setSaving( true );

			const model = new wp.api.models.Settings( {
				'wp-verify-nft-asset-address': props.data.nftAddress,
				'wp-verify-nft-success-text': props.data.successOutputMessage,
				'wp-verify-nft-failure-text': props.data.failureOutputMessage,
			} );

			await model.save();
		} catch ( error ) {
			props.noticeOperations.createErrorNotice(
				'Something went wrong, Please try again'
			);
		} finally {
			setSaving( false );
		}
	};

	return (
		<div className="wpnftverify-pre-verification-form">
			<TextControl
				label="NFT Address"
				value={ props.data.nftAddress }
				placeholder="Enter you address here..."
				help="WEB3 Token Gate only works on Ethereum main net. Enter the contract address of the Ethereum nft you wish to verify here."
				onChange={ ( newNFTAddress ) =>
					props.setData( {
						...props.data,
						nftAddress: newNFTAddress,
					} )
				}
			/>

			<TextControl
				label="Success Message"
				value={ props.data.successOutputMessage }
				placeholder="Enter you message here..."
				help="Enter the message that should be displayed when the user has verified NFT."
				onChange={ ( newSuccessOutputMessage ) =>
					props.setData( {
						...props.data,
						successOutputMessage: newSuccessOutputMessage,
					} )
				}
			/>

			<TextControl
				label="Success Message"
				value={ props.data.failureOutputMessage }
				placeholder="Enter you address here..."
				help="Enter the message that should be displayed when the does not user has verified NFT."
				onChange={ ( newFailureOutputMessage ) =>
					props.setData( {
						...props.data,
						failureOutputMessage: newFailureOutputMessage,
					} )
				}
			/>

			{ props.noticeUI }

			<div className="wpnftverify-pre-verification-form-footer">
				<Button
					variant="primary"
					isBusy={ isSaving }
					onClick={ onDataProcessRequest }
				>
					{ isSaving ? 'Saving...' : 'Save' }
				</Button>
			</div>
		</div>
	);
}

export default withNotices( VerificationForm );
