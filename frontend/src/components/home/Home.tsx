import React, { Component } from 'react';

import './Home.scss';

export interface Props {
}

interface State {
}

class Home extends Component<Props, State> {
  constructor(props: Props) {
    super(props);
    this.state = {
    };
  }

  render() {
    return (
      <div>Home</div>
    );
  }

}

export default Home;
