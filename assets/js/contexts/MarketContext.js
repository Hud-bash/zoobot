import React, {createContext} from 'react';

export const MarketContext = createContext();

class MarketContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            listings: [{
                nft: 'NFT value',
                price: '5000',
                currency: 'ZOO',
                seller: 'Bob Schmill',
                timestamp: '5/5/2020'
            }],
        };
    }

    //create
    createMarket() {

    }

    //read
    readMarket() {

    }
    //update
    updateMarket() {

    }
    //delete
    deleteMarket() {

    }

    render() {
        return (
            <MarketContext.Provider value={{
                ...this.state,
                createMarket: this.createMarket.bind(this),
                updateMarket: this.updateMarket.bind(this),
                deleteMarket: this.deleteMarket.bind(this),
                setMessage: (message) => this.setState({message: message}),
            }}>
                {this.props.children}
            </MarketContext.Provider>
        );
    }
}

export default MarketContextProvider;