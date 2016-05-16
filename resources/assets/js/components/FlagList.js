import React, { Component } from 'react'
import Flag from "./Flag"

class FlagList extends Component {

    render() {
        return (
            <div className="flag-list">
                {this.props.countries.map((country) => {
                    return (
                        <Flag
                            selected={this.props.selectedCountry && this.props.selectedCountry.id === country.id}
                            disabled={this.props.disabled}
                            key={country.id}
                            country={country}
                            onLoadStart={this.props.onLoadStart}
                            onLoadStop={this.props.onLoadStop}
                            onCountrySelected={this.props.onCountrySelected}
                        />
                    )
                })}
            </div>
        )
    }

}

export default FlagList