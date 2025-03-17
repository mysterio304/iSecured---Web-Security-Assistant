const myApp = (function () {
	const msg = document.querySelector("error-text")

	function getAllToolTips() {
		[...document.querySelectorAll('[data-bs-toggle="tooltip"]')].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl, { html: true }))
	}

	function init() {
		getAllToolTips()

		// REGISTER
		register = document.querySelector("#register")
		if (register) {
			errorText = document.querySelector("#errorText")
			register.addEventListener("submit", function (e) {
				e.preventDefault()
				email = this.querySelector("#email")
				password = this.querySelector("#password")
				confirmPassword = this.querySelector("#confirmPassword")

				var myHeaders = new Headers()
				myHeaders.append("Content-Type", "application/x-www-form-urlencoded")

				var urlencoded = new URLSearchParams()
				urlencoded.append("email", email.value)
				urlencoded.append("password", password.value)
				urlencoded.append("confirm_password", confirmPassword.value)
				
				var requestOptions = {
					method: "POST",
					headers: myHeaders,
					body: urlencoded,
					redirect: "follow"
				}

				fetch("/registerUser", requestOptions)
					.then((response) => response.json())
					.then((data) => {
						if (data["status"]) {
							window.location.replace("/")
						} else if (data["status"] == false) {
							errorText.innerHTML = data["msg"]
						}
					})
					.catch(error => console.log("error", error))
			})
		}


		// LOGIN
		login = document.querySelector("#login")
		if (login) {
			errorText = document.querySelector("#errorText")
			login.addEventListener("submit", function (e) {
				e.preventDefault()
				email = this.querySelector("#email")
				password = this.querySelector("#password")
				rememberMe = this.querySelector("#rememberMe")

				var myHeaders = new Headers()
				myHeaders.append("Content-Type", "application/x-www-form-urlencoded")

				var urlencoded = new URLSearchParams()
				urlencoded.append("email", email.value)
				urlencoded.append("password", password.value)
				urlencoded.append("rememberMe", rememberMe.checked)

				var requestOptions = {
					method: "POST",
					headers: myHeaders,
					body: urlencoded,
					redirect: "follow"
				}

				fetch("/loginUser", requestOptions)
					.then((response) => response.json())
					.then((data) => {
						if (data["status"]) {
							window.location.replace("/")
						} else if (data["status"] == false) {
							errorText.innerHTML = data["msg"]
						}
					})
					.catch(error => console.log("error", error))
			})
		}

        // GOOGLE LOGIN
        googleBtn = document.querySelector("#googleLogin")
        if (googleBtn) {
            errorText = document.querySelector("#errorText")
            googleBtn.addEventListener("click", function (e) {
                e.preventDefault()
                
                var myHeaders = new Headers()
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded")

                var urlencoded = new URLSearchParams()

                var requestOptions = {
                    method: "POST",
                    headers: myHeaders,
                    redirect: "follow"
                }

                fetch("/loginGoogleUser", requestOptions)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data['status']) {
                            window.location.replace(data['msg'])
                        } else {
                            errorText.innerHTML = data['msg']
                        }
                    })
            })
        }


		// RESET PASSWORD
		reset = document.querySelector("#reset")
		if (reset) {
			errorText = document.querySelector("#errorText")
			reset.addEventListener("submit", function (e) {
				e.preventDefault()
				email = this.querySelector("#email")

				var myHeaders = new Headers()
				myHeaders.append("Content-Type", "application/x-www-form-urlencoded")

				var urlencoded = new URLSearchParams()
				urlencoded.append("email", email.value)

				var requestOptions = {
					method: "POST",
					headers: myHeaders,
					body: urlencoded,
				}

				fetch("/sendPasswordReset", requestOptions)
					.then((response) => response.json())
					.then((data) => {
						if (data["status"]) {
							errorText.innerHTML = data["msg"]
						} else if (data["status"] == false) {
							errorText.innerHTML = data["msg"]
						}
					})
					.catch(error => console.log("error", error))
			})
		}

        
        // UPDATE PASSWORD
        update = document.querySelector('#updatePassword')
        if (update) {
            errorText = document.querySelector('#errorText')
			updateSuccessBlock = document.querySelector('.update-success-block')
            update.addEventListener('submit', function (e) {
                e.preventDefault()
                password = this.querySelector('#password')
                confPassword = this.querySelector('#confPassword')

                const searchParams = new URLSearchParams(window.location.search)
                token = searchParams.get('token')

                var myHeaders = new Headers()
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded")

                var urlencoded = new URLSearchParams()
                urlencoded.append("password", password.value)
                urlencoded.append("confirm_password", confPassword.value)
                urlencoded.append("token", token)

                var requestOptions = {
                    method: "POST",
                    headers: myHeaders,
                    body: urlencoded
                }

                fetch("/updatePassword", requestOptions)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data['status']) {
							updateSuccessBlock.style.display = 'block'
                        } else if (data['status'] == false) {
                            errorText.innerHTML = data['msg']
							updateSuccessBlock.style.display = 'none'
                        }
                    })
                    .catch(error => console.log('error', error))
            })
        }


        // SEND CONFIRMATION CODE
        submitConfirmation = document.querySelector('#submitEmailConfirmation')
        if (submitConfirmation) {
            getConfirmationBtn = document.querySelector('#getConfirmationCode')
            submitConfirmationBtn = document.querySelector('#submitConfirmationCode')
            getConfirmationBlock = document.querySelector('#getConfirmationCodeBlock')
            submitConfirmationBlock = document.querySelector('#submitConfirmationCodeBlock')
            
            errorText = document.querySelector('#errorText')
            getConfirmationBtn.addEventListener('click', function (e) {
                e.preventDefault()

                var myHeaders = new Headers()
                myHeaders.append('Content-Type', 'application/x-www-form-urlencoded')

                var urlencoded = new URLSearchParams()

                var requestOptions = {
                    method: "POST",
                    headers: myHeaders,
                    body: urlencoded
                }

                fetch("/sendConfirmEmail", requestOptions)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data['status']) {
                            getConfirmationBlock.style.display = 'none'
                            submitConfirmationBlock.style.display = 'block'

                            submitConfirmation.addEventListener('submit', function (e) {
                                e.preventDefault()
                                emailConfirmationCode = this.querySelector('#confirmationCode')

                                var myHeaders = new Headers()
                                myHeaders.append('Content-Type', 'application/x-www-form-urlencoded')

                                var urlencoded = new URLSearchParams()
                                urlencoded.append('email_confirm_code', emailConfirmationCode.value)

                                var requestOptions = {
                                    method: "POST",
                                    headers: myHeaders,
                                    body: urlencoded
                                }

                                fetch("/confirmEmail", requestOptions)
                                    .then((response) => response.json())
                                    .then((data) => {
                                        if (data['status']) {
                                            errorText.innerHTML = `${data['msg']}. <a href='/'>Go to home page</a>`
                                        } else if (data['status'] == false) {
                                            errorText.innerHTML = data['msg']
                                        }
                                    })
                                    .catch (error => console.log('error', error))
                            })
                        } else if (data['status'] == false) {
                            errorText.innerHTML = data['msg']
                        }
                    })
                    .catch(error => console.log('error', error))

            })
        }


        // SEND QUERY TO AI
        queryForm = document.querySelector("#query-form")
        if (queryForm) {
            responseField = document.querySelector("#response-field")

            queryForm.addEventListener("submit", function (e) {
                e.preventDefault()

                queryValue = this.querySelector("#query-field")
                queryValueSpecific = "Imagine that you are an expert in cybersecurity and Internet security. You are asked for questions in the fields of cybersecurity and Internet security. You provide the answer only about these topics. Use no more then 40 words for answering the question. The question is: " + queryValue.value
                
                var myHeaders = new Headers()
                myHeaders.append("Content-Type", "application/x-www-form-urlencoded")

                var urlencoded = new URLSearchParams()
                urlencoded.append("message", queryValueSpecific)

                var requestOptions = {
                    method: "POST",
                    headers: myHeaders,
                    body: urlencoded
                }

                fetch("/getResponseFromAI", requestOptions)
                    .then((response) => response.json())
                    .then((data) => {
                        if (data['status']) {
                            responseField.innerHTML = data['msg']
                        } else {
                            responseField.innerHTML = data['msg']
                        }
                    })
                    .catch(error => console.log('error', error))

            })
        }

	}
	return { init: init }
})()

myApp.init()