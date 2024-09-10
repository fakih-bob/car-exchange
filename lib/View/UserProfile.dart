import 'package:carexchange/Components/PostsPageBar.dart';
import 'package:carexchange/Controller/PostController.dart';
import 'package:carexchange/Controller/UpdateUser.dart';
import 'package:carexchange/Controller/UserContoller.dart';
import 'package:carexchange/Routes/AppRoute.dart';
import 'package:carexchange/View/UpdateUser.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';

class UserProfile extends StatefulWidget {
  const UserProfile({Key? key}) : super(key: key);

  @override
  _UserProfileState createState() => _UserProfileState();
}

class _UserProfileState extends State<UserProfile> {
  final PostController postController = Get.put(PostController());
  final Updateusercontroller updateUserController =
      Get.put(Updateusercontroller());
  final UserController userController = Get.put(UserController());

  @override
  void initState() {
    super.initState();
    userController.getUser();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFFF5F7FA), // Softer background color
      appBar: AppBar(
        title: const Text('Favorite Posts'),
        leading: IconButton(
          icon: const Icon(Icons.arrow_back),
          onPressed: () {
            Get.offNamed(
                AppRoute.posts); // Navigates back to the previous screen
          },
        ),
      ),

      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.all(16.0),
          child: Obx(() {
            var user = userController.user.value;

            return Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              children: [
                SizedBox(height: 30),

                // User Avatar at the top center
                CircleAvatar(
                  radius: 65,
                  backgroundColor: const Color.fromARGB(
                      255, 4, 59, 154), // Outer circle color
                  child: CircleAvatar(
                    radius: 56,
                    backgroundImage: AssetImage(
                      'assets/images/avatar.png', // Replace with user's profile image URL
                    ),
                  ),
                ),
                SizedBox(height: 20),

                // Display the Name
                Text(
                  user.name,
                  style: TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 28,
                    color: Colors.black87,
                  ),
                ),
                SizedBox(height: 15),

                // Display the Email
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(Icons.email,
                        color: const Color.fromARGB(255, 4, 59, 154)),
                    SizedBox(width: 10),
                    Text(
                      user.email,
                      style: TextStyle(
                        fontSize: 20,
                        color: Colors.black54,
                      ),
                    ),
                  ],
                ),
                SizedBox(height: 12),

                // Display the Phone Number
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(Icons.phone,
                        color: const Color.fromARGB(255, 4, 59, 154)),
                    SizedBox(width: 10),
                    Text(
                      user.phoneNumber,
                      style: TextStyle(
                        fontSize: 20,
                        color: Colors.black54,
                      ),
                    ),
                  ],
                ),
                SizedBox(height: 30),

                // Edit Profile Button
                ElevatedButton.icon(
                  onPressed: () {
                    updateUserController.updateFormFields(user);
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (context) => Updateuser(
                          user: user,
                        ),
                      ),
                    );
                  },
                  icon: Icon(Icons.edit),
                  label: Text('Edit Profile'),
                  style: ElevatedButton.styleFrom(
                    foregroundColor: Colors.white,
                    backgroundColor: const Color.fromARGB(255, 4, 59, 154),
                    padding: EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                    textStyle: TextStyle(fontSize: 18),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(30),
                    ),
                  ),
                ),
                const SizedBox(
                  height: 20,
                ),
                ElevatedButton.icon(
                  onPressed: () {
                    updateUserController.DeleteUser();
                    postController.logOut();
                  },
                  icon: Icon(Icons.delete_forever),
                  label: Text('Delete account'),
                  style: ElevatedButton.styleFrom(
                    foregroundColor: Colors.white,
                    backgroundColor: const Color.fromARGB(255, 4, 59, 154),
                    padding: EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                    textStyle: TextStyle(fontSize: 18),
                    shape: RoundedRectangleBorder(
                      borderRadius: BorderRadius.circular(30),
                    ),
                  ),
                ),
              ],
            );
          }),
        ),
      ),
    );
  }
}
