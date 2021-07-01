import React, {createContext} from 'react';
import axios from "axios";

export const WalletContext = createContext();

class WalletContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            wallets: [],
        };
        this.readWallet();
    }

    //create
    createWallet() {

    }

    //read
    readWallet() {
        axios.get('/api/wallet')
            .then(response => {
                this.setState({
                    wallets: response.data,
                });
            }).catch(error => {
            console.error(error);
        })
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