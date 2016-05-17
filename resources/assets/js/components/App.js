import React, { Component } from 'react'
import FlagList from "./FlagList"
import Loading from "./Loading"
import Error from "./Error"
import * as Api from "../helpers/api"
import PhoneNumber from "./PhoneNumber"

// TODO refactor all that
var App = React.createClass({

    toggleError(error) {
        this.setState({error: error});
    },

    getInitialState() {
        return {loading: false};
    },

    toggleLoader(state) {
        this.setState({loading: state});
    },

    onCountryFlagClick(country) {
        this.selectCountry(country);
        this.fetchCountry(country.code)
    },

    selectCountry(country) {
        this.setState({selectedCountry: country});
    },

    selectPhone(phone) {
        this.setState({phone: phone});
    },

    fetchCountry(countryCode) {
        if (this.state.loading) {
            // TODO debounce fetchCountry.
            return;
        }
        this.toggleLoader(true);
        Api.get('/country/' + countryCode)
            .then((response) => {
                this.toggleError("");
                this.toggleLoader(false);
                if (!response) {
                    return Promise.reject(response)
                }

                if (!response.phone || !response.phone.phone_number) {
                    this.toggleError("Sorry, no phone available for this country so far. But please do try again later.")
                    return
                }
                this.selectPhone(response.phone.phone_number);
            })
            .catch((e) => {
                this.toggleLoader(false);
                this.toggleError("Sorry, something went wrong down there. But do not fear, for we will fix it soon.")
                // Keep promise rejected
                throw e
            })
    },

    renderError() {
        if (!this.state.error || this.state.loading) {
            return
        }
        return (
            <Error error={this.state.error} />
        )
    },

    renderCountryPrompt() {
        let text = 'Choose your country';
        if (this.state.loading) {
            text = 'Please, wait';
        }
        if (this.state.phone) {
            text = 'Dial now:';
        }
        return (
            <h2>{text}</h2>
        )
    },

    renderLoader() {
        if (!this.state.loading) {
            return
        }
        return (
            <Loading />
        )
    },

    renderFlagList() {
        if (this.state.phone) {
            return
        }
        return (
            <FlagList
                disabled={this.state.loading}
                countries={window.countries}
                selectedCountry={this.state.selectedCountry}
                onLoadStart={() => this.toggleLoader(true)}
                onLoadStop={() => this.toggleLoader(false)}
                onCountrySelected={this.onCountryFlagClick}
            />
        )
    },

    renderPhoneNumber() {
        if (!this.state.phone) {
            return
        }
        return (
            <PhoneNumber number={this.state.phone} />
        )
    },

    renderBackButton() {
        if (!this.state.phone || !this.state.selectedCountry) {
            return
        }
        return (
            <div
                className="back-button"
                onClick={() => {
                    this.selectCountry(null);
                    this.selectPhone("");
                }}
            >
                ← or choose another country
            </div>
        )
    },

    render() {

        return (
            <div>
                <h1 className="header">
                    Better call <span className="header-highlight">us</span>
                </h1>

                <div className="subheader">
                    {this.renderError()}
                    {this.renderCountryPrompt()}
                    {this.renderLoader()}
                </div>

                {this.renderFlagList()}
                {this.renderPhoneNumber()}
                {this.renderBackButton()}
            </div>
        )
    }
});

export default App