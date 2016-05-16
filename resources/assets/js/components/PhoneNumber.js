import React, { Component } from 'react'
import classNames from "classnames"

class PhoneNumber extends Component {

    render() {
        return (
            <div className={classNames("phone-number", this.props.className)}>{this.props.number}</div>
        )
    }

}

export default PhoneNumber