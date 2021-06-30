import React, {createContext} from 'react';

export const NftContext = createContext();

class NftContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            nfts: [{
                isLocked: 'true',
                url: 'stuff.jpg',
                id: '155',
                name: 'Fruity fluffy fluff stuff',
                category: 'Magic',
                item: '3 Stars',
                level: 'Level 5'
            }],
        };
    }

    //create
    createNft() {

    }

    //read
    readNft() {

    }
    //update
    updateNft() {

    }
    //delete
    deleteNft() {

    }

    render() {
        return (
            <NftContext.Provider value={{
                ...this.state,
                createNft: this.createNft.bind(this),
                updateNft: this.updateNft.bind(this),
                deleteNft: this.deleteNft.bind(this),
            }}>
                {this.props.children}
            </NftContext.Provider>
        );
    }
}

export default NftContextProvider;