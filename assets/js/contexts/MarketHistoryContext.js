import React, {createContext} from 'react';

export const MarketHistoryContext = createContext();

class MarketHistoryContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            sales: [{
                nft: 'NFT value',
                price: '5000',
                currency: 'ZOO',
                seller: 'Bob Schmill',
                buyer: 'Alf Fitzgerald',
                timestamp: '5/5/2020'
            }],
        };
    }

    //create
    createMarketHistory() {

    }

    //read
    readMarketHistory() {

    }
    //update
    updateMarketHistory() {

    }
    //delete
    deleteMarketHistory() {

    }

    render() {
        return (
            <MarketHistoryContext.Provider value={{
                ...this.state,
                createMarketHistory: this.createMarketHistory.bind(this),
                updateMarketHistory: this.updateMarketHistory.bind(this),
                deleteMarketHistory: this.deleteMarketHistory.bind(this),
            }}>
                {this.props.children}
            </MarketHistoryContext.Provider>
        );
    }
}

export default MarketHistoryContextProvider;