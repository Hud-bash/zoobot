import React, {createContext} from 'react';

export const HomeContext = createContext();

class HomeContextProvider extends React.Component {
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
    createHome() {

    }

    //read
    readHome() {

    }
    //update
    updateHome() {

    }
    //delete
    deleteHome() {

    }

    render() {
        return (
            <HomeContext.Provider value={{
                ...this.state,
                createHome: this.createHome.bind(this),
                updateHome: this.updateHome.bind(this),
                deleteHome: this.deleteHome.bind(this),
            }}>
                {this.props.children}
            </HomeContext.Provider>
        );
    }
}

export default HomeContextProvider;