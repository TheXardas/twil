import React, { Component } from 'react'
import classNames from "classnames"

class Error extends Component {

    render() {
        return (
            <div className={classNames("error", this.props.className)}>{this.props.error}</div>
        )
    }

}

export default Error