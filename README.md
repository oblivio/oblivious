# oblivious
Zero knowledge.

oblivious 0.0.1 Alpha - 

==== THIS IS ALPHA SOFTWARE - USE AT YOUR OWN RISKS ====

oblivious is essentially a file based content management system with a focus on encryption, security and privacy.


oblivious began while trying to further modularize a fork of the anonymous pastebin called ZeroBin; 


The oblivious system itself is built in a very simple, easy to understand way. When you create a new entry, all you are doing is creating a file (following a particular folder/naming structure); The contents of the file will be the contents of your entry (but encrypted with a server key); This entry can have certain attributes like expiration time, burnafterreading, and open-discussions(comments). If you are the creator of an entry, you will get a special 'delete token' that let's you remove the entry before its expiration date. 

oblivious also provides a mechanism to 'invite' users into entries, allows users to comment on entries, add images to content or comments, password protect specific content, and even specify expiration times. This feature-set is sure to expand in the future.

The oblivious system is built on the Slim framework - a microframework for PHP.

http://www.slimframework.com/



=== ORIGINS ===

oblivious has its origins in ZeroBin - a minimalist, opensource online pastebin where the server 
has zero knowledge of pasted data. 

More information on the project page:

http://sebsauvage.net/wiki/doku.php?id=php:zerobin


------------------------------------------------------------------------------
------------------------------------------------------------------------------

Copyright (c) 2015 Fabian Valle (www.fabian-valle.com)

This software is provided 'as-is', without any express or implied warranty.
In no event will the authors be held liable for any damages arising from 
the use of this software.

Permission is granted to anyone to use this software for any purpose, 
including commercial applications, and to alter it and redistribute it 
freely, subject to the following restrictions:

    1. The origin of this software must not be misrepresented; you must 
       not claim that you wrote the original software. If you use this 
       software in a product, an acknowledgment in the product documentation
       would be appreciated but is not required.

    2. Altered source versions must be plainly marked as such, and must 
       not be misrepresented as being the original software.

    3. This notice may not be removed or altered from any source distribution.

------------------------------------------------------------------------------
------------------------------------------------------------------------------

Copyright (c) 2012 Sébastien SAUVAGE (sebsauvage.net)

This software is provided 'as-is', without any express or implied warranty.
In no event will the authors be held liable for any damages arising from 
the use of this software.

Permission is granted to anyone to use this software for any purpose, 
including commercial applications, and to alter it and redistribute it 
freely, subject to the following restrictions:

    1. The origin of this software must not be misrepresented; you must 
       not claim that you wrote the original software. If you use this 
       software in a product, an acknowledgment in the product documentation
       would be appreciated but is not required.

    2. Altered source versions must be plainly marked as such, and must 
       not be misrepresented as being the original software.

    3. This notice may not be removed or altered from any source distribution.

------------------------------------------------------------------------------
------------------------------------------------------------------------------

This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

-------------------------------------------------------------------------------
