const validation=new JustValidate("#register-form");// id for registration/signup form

validation
    .addField("#name",[ //id for name field
        {
             rule:"required" // name field is required to be filled
        }
    ])
    .addField("#address",[ //id for address field
        {
             rule:"required" // address field is required to be filled
        }
    ])
    .addField("#phone",[ //id for phone field
        {
             rule:"required" // phone field is required to be filled
        }
    ])
    .addField("#email",[ //id for email field
        {
            rule:"required" // email field is required to be filled
        },
        {
            rule:"email" // format for email eg. example@gmail.com
        },
        {
            validator:(value) => () => {                        //Check to see if email exists in the database
                return fetch("validemail.php?email="+ encodeURIComponent(value))
                    .then(function(response){
                           return response.json();
                     })
                    .then(function(json){
                           return json.available;
                    });
            },
            errorMessage:"Email already taken"

        }
    ])
    .addField("#pass",[// id for password field
        {
            rule:"required" // password field is required to be filled

        },
        {
            rule:"password" //format for password 
        }
    ])
    .addField("#confirmpass",[ // id for confirm password field
        {
            validator:(value,fields)=>{ // check to see if both passwords match
                return value === fields["#pass"].elem.value;
            },
            errorMessage:"Passwords should match"
        }
    ])
    .onSuccess((event) =>{
        document.getElementById("register-form").submit();//submit form
    })
