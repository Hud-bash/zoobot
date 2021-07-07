const WalletProfileLink = (props) => {

    const baseUrl = 'api/profile/';

    return <a href={baseUrl + props.walletId} />;
}