import React, {createContext} from 'react';
import axios from "axios";

export const WalletContext = createContext();

class WalletContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            count: 0,
            page: 1,
            resultsPerPage: 50,
            wallets: [],
        };
        this.readWallet([this.state.page, this.state.resultsPerPage]);
    }

    //create
    createWallet() {

    }

    //read
    readWallet(props) {
        axios.get('/api/wallet/' + props[0] + '-' + props[1])
            .then(response => {
                this.setState({
                    count: response.data.count,
                    page: props[0],
                    resultsPerPage: props[1],
                    wallets: response.data.wallets,
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
                readWallet: this.readWallet.bind(this),
                updateWallet: this.updateWallet.bind(this),
                deleteWallet: this.deleteWallet.bind(this),
            }}>
                {this.props.children}
            </WalletContext.Provider>
        );
    }
}

export default WalletContextProvider;