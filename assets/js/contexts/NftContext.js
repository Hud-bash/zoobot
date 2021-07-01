import React, {createContext} from 'react';
import axios from "axios";

export const NftContext = createContext();

class NftContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            nfts: [],
        };
        this.readNft();
    }

    //create
    createNft() {

    }

    //read
    readNft() {
        axios.get('/api/nft')
            .then(response => {
                this.setState({
                    nfts: response.data,
                });
            }).catch(error => {
            console.error(error);
        })
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