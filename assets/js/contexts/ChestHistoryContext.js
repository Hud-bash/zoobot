import React, {createContext} from 'react';

export const ChestHistoryContext = createContext();

class ChestHistoryContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            chesties: [{
                nft: 'NFT value',
                type: 'SilverChest',
                amount: '13000',
                owner: 'Bob Schmill',
                timestamp: '5/5/2020'
            }],
        };
    }

    //create
    createChestHistory() {

    }

    //read
    readChestHistory() {

    }
    //update
    updateChestHistory() {

    }
    //delete
    deleteChestHistory() {

    }

    render() {
        return (
            <ChestHistoryContext.Provider value={{
                ...this.state,
                createChestHistory: this.createChestHistory.bind(this),
                updateChestHistory: this.updateChestHistory.bind(this),
                deleteChestHistory: this.deleteChestHistory.bind(this),
            }}>
                {this.props.children}
            </ChestHistoryContext.Provider>
        );
    }
}

export default ChestHistoryContextProvider;