import React from 'react';
const styles = {
    home: {
        padding: '50px',
        textAlign: 'center',
    }
};
export default class Home extends React.Component {
    render() {
        return <div style={styles.home}>
            <h1>ZooStation</h1>

            <p>Orbital hub of commerce for all zookeepers.</p>
        </div>;
    }
}
