#!/usr/bin/ruby
require 'rubygems'
require 'RMagick'
require 'net/http'
require 'open-uri'

include Magick

rows = (ARGV.count/12) + 1
height = rows.round * (50 +20)

ilist = Magick::ImageList.new
montage = Magick::Image.new(500,height)
montage.background_color = "black"

#puts ARGV[0]
filename = "user_images/" + ARGV[0].to_s + "_friendwall.jpeg"
ARGV.delete_at(0)
STDOUT.sync = true
ARGV.each do |a|
#	print "."
	myprofilepic = "https://graph.facebook.com/#{a}/picture?type=square"	
	imgdata = open(myprofilepic)
	im1 = Magick::Image.from_blob(imgdata.string).first
	ilist << im1
end
#puts "about to start montage"
montage = ilist.montage do
	self.background_color="black"
	self.border_color="black"
	self.geometry = "50x50+5+5"
	self.tile = "12x"+rows.to_s
end
overlay = ImageList.new("https://s3.amazonaws.com/momentus-files/friendwall/Treeoverlay3.png")
result = overlay.composite(montage,0,297,Magick::OverlayCompositeOp)
result.write(filename)
puts filename