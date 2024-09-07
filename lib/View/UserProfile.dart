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
    // Fetch user data when the screen initializes
    userController.getUser();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Color(0xFFF5F7FA), // Softer background color
      appBar: AppBar(
        automaticallyImplyLeading: true,
        title: const PostsPageBar(),
        elevation: 0,
        backgroundColor: Colors.transparent,
      ),
      drawer: Drawer(
        backgroundColor: const Color.fromARGB(255, 4, 59, 154),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.end,
          children: [
            SizedBox(height: 45),
            const Text(
              "Welcome, User!",
              style: TextStyle(
                  color: Colors.white,
                  fontSize: 20,
                  fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                Get.offNamed(AppRoute.newpost);
              },
              child: const Text("New post"),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                Get.offNamed(AppRoute.MyLikes);
              },
              child: const Text("Show my favorites"),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: () {
                Get.offNamed(AppRoute.MyPosts);
              },
              child: const Text("Show my posts"),
            ),
            const Spacer(),
            ElevatedButton(
              onPressed: () {
                postController.logOut();
              },
              child: const Text("Logout"),
            ),
            const SizedBox(height: 40),
          ],
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
              ],
            );
          }),
        ),
      ),
    );
  }
}
