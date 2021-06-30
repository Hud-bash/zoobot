import React, {createContext} from 'react';

export const WalletContext = createContext();

class WalletContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            wallets: [{
                wallet_id: '0x83y5873285829hf28f2hfhf28',
                name: 'Bob Schmill',
                animal: 'Sleepy Lion'
            }],
        };
    }

    //create
    createWallet() {

    }

    //read
    readWallet() {

    }
    //update
    updateWallet() {

    }
    //delete
    deleteWallet() {

    }

    render() {
        return (
            <WalletContext.Provider value={{
                ...this.state,
                createWallet: this.createWallet.bind(this),
                updateWallet: this.updateWallet.bind(this),
                deleteWallet: this.deleteWallet.bind(this),
            }}>
                {this.props.children}
            </WalletContext.Provider>
        );
    }
}

export default WalletContextProvider;