class Form {
    constructor (input) {
        this.input = input;
    }

    /**
    Takes a string in the form: "rule1|rule2|rule3|etc..."
    **/
    validate (rules) {
        this.rules = rules.split("|");
        console.log(this.rules);
        let m = this.rules[0];
        if (this[m]()) {
            console.log('Passed validation');
        }
        else {
            console.log('Failed validation');
        }
    }

    min () {
        console.log('Calling min.');
        let str = this.input.val();
        console.log(str);
        return (str.length + 1) >= 8;
    }


}
