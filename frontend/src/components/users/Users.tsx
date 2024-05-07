import React, { Component } from 'react';

import './Users.scss';

export interface Props {
}

interface State {
}

class Users extends Component<Props, State> {
  constructor(props: Props) {
    super(props);
    this.state = {
    };
  }

  render() {
    return (
      <div>Users</div>
    );
  }

}

export default Users;
