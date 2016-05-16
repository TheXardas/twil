import React, { Component } from 'react'
import classNames from "classnames"

class Loading extends Component {

    render() {
        return (
            <div className={classNames("loader", this.props.className)}>
                <div className="bounce1"></div>
                <div className="bounce2"></div>
                <div className="bounce3"></div>
            </div>
        )
    }

}

export default Loading