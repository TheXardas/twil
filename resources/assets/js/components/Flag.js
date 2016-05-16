import React, { Component } from 'react'
import classNames from "classnames"

class Flag extends Component {

    render() {
        var country = this.props.country;
        return (
            <div
                className={classNames("flag", {selected: this.props.selected})}
                onClick={
                    this.props.disabled
                    ? null
                    : () => {
                        this.props.onCountrySelected(country)
                }}
            >
                <img
                    className="flag-image"
                    src={`/img/flags/${country.code}.jpg`}
                    alt={country.name}
                    title={country.name}
                />

            </div>
        )
    }

}

export default Flag;