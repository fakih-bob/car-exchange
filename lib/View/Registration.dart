import 'package:carexchange/Components/MyTextField.dart';
import 'package:carexchange/Controller/RegistrationController.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class Registration extends GetView<RegistrationController> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey,
      body: SingleChildScrollView(
        child: SafeArea(
            child: Center(
          child: Column(
            children: [
              const SizedBox(
                height: 20,
              ),
              Container(
                  width: 150,
                  height: 150,
                  decoration: BoxDecoration(
                    image: const DecorationImage(
                      image: AssetImage('assets/images/logo.png'),
                      fit: BoxFit.cover,
                    ),
                    borderRadius: BorderRadius.circular(15),
                  )),
              const SizedBox(
                height: 30,
              ),
              const Text(
                "Registration",
                style: TextStyle(
                  color: Colors.black,
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                ),
              ),
              const SizedBox(
                height: 50,
              ),
              MyTextfield(
                obscureText: false,
                hintText: 'Name',
                controller: controller.name,
              ),
              const SizedBox(
                height: 20,
              ),
              MyTextfield(
                obscureText: false,
                hintText: 'Email',
                controller: controller.email,
              ),
              const SizedBox(
                height: 20,
              ),
              MyTextfield(
                obscureText: false,
                hintText: 'PhoneNumber',
                controller: controller.phoneNumber,
              ),
              const SizedBox(
                height: 20,
              ),
              MyTextfield(
                obscureText: true,
                hintText: 'Password',
                controller: controller.password,
              ),
              const SizedBox(height: 7),
              const Padding(
                padding: EdgeInsets.symmetric(horizontal: 25.0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    Text(
                      "Have an account?",
                      style: TextStyle(color: Colors.black),
                    )
                  ],
                ),
              ),
              const SizedBox(
                height: 18,
              ),
              ElevatedButton(
                onPressed: () {
                  controller.register();
                },
                style: ElevatedButton.styleFrom(
                  foregroundColor: Colors.white,
                  backgroundColor: Colors.black,
                  shadowColor: Colors.black,
                  elevation: 10,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(8),
                  ),
                  padding:
                      const EdgeInsets.symmetric(horizontal: 100, vertical: 20),
                  textStyle: const TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                child: const Text('Registration'),
              ),
            ],
          ),
        )),
      ),
    );
  }
}
