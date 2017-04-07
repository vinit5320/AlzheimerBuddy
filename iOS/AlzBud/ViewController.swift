//
//  ViewController.swift
//  AlzBud
//
//  Created by Vinit Jasoliya on 4/3/17.
//  Copyright © 2017 Vinit Jasoliya. All rights reserved.
//

import UIKit
import Speech
import AVFoundation
import Alamofire


class ViewController: UIViewController {
    
    @IBOutlet weak var userInputField: UITextField!
    @IBOutlet weak var outputLabel: UILabel!
    @IBOutlet weak var myImageView: UIImageView!
    
    var objectDic : [String:String] = ["pen":"top shelf in your room","watch":"the dining table"]
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        let url = URL(string: image.url)
        let data = try? Data(contentsOf: url!) //make sure your image in this url does exist, otherwise unwrap in a if let check / try-catch
        myImageView.image = UIImage(data: data!)
        
    }
    
    
    @IBAction func searchPress(_ sender: Any) {
        
        //var query = userInputField.text
        
        
    }

    
}


